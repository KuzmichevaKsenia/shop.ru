<?php
require_once "modules_class.php";

class NotFoundContent extends Modules
{

    protected $title = "Страница не найдена - 404";
    protected $meta_desc = "Запрошенная страница не существует";
    protected $meta_key = "страница не найдена, страница не существует, 404";

    public function getContent()
    {
        header("HTTP/1.0 404 Not Found");
        return "notfound";
    }

}
