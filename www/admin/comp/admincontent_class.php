<?php
require_once "adminmodules_class.php";

class AdminContent extends AdminModules
{ //главная страница

    protected $title = "Аккаунт администратора";
    protected $meta_desc = "Аккаунт администратора Интернет-магазина.";
    protected $meta_key = "администратор, аккаунт администратор, аккаунт администратора интернет магазин";

    public function getContent()
    {
        $start = $this->format->getTime("", true);
        $end = $this->format->getTime("", false);
        $result = $this->statistics->getDataForAdmin($start, $end);
        $this->template->set("result", $result);
        return "index";
    }

}
