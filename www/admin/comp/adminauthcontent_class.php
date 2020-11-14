<?php
require_once "adminmodules_class.php";

class AdminAuthContent extends AdminModules
{ //главная страница

    protected $title = "Вход в аккаунт администратора";
    protected $meta_desc = "Вход в аккаунт администратора.";
    protected $meta_key = "администратор, аккаунт администратора, аккаунт администратора вход";

    public function __construct()
    {
        parent::__construct(false);
    }

    public function getContent()
    {
        if ($this->template->auth) {
            $this->redirect($this->url_admin->index());
        }
        if ($_SERVER["HTTP_REFERER"] != $this->url_admin->getThisURL() && $_SERVER["HTTP_REFERER"] != $this->url_admin->action()) {
            $_SESSION["r"] = $_SERVER["HTTP_REFERER"];
        }
        $this->template->set("login", $_SESSION["login"]);
        $this->template->set("r", $_SESSION["r"]);
        return "auth";
    }

}
