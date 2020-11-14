<?php
require_once "adminmodules_class.php";

class AdminStatisticsContent extends AdminModules
{

    protected $title = "Статистика";
    protected $meta_desc = "Статистика интернет-магазина.";
    protected $meta_key = "статистика, аккаунт администратор, аккаунт администратора интернет магазин";

    public function getContent()
    {
        $start = $this->format->getTime($_GET["start"], true);
        $end = $this->format->getTime($_GET["end"], false);
        $result = $this->statistics->getDataForAdmin($start, $end);
        $this->template->set("result", $result);
        $this->template->set("start", $this->format->time($start));
        $this->template->set("end", $this->format->time($end));
        return "statistics";
    }

}
