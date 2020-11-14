<?php
require_once "lib/abstractmodules_class.php";
require_once "lib/urladmin_class.php";
require_once "lib/auth_class.php";
require_once "lib/statistics_class.php";

abstract class AdminModules extends AbstractModules
{

    protected $url_admin;
    protected $page_info;
    protected $statistics;

    public function __construct($check_auth = true)
    {
        parent::__construct();

        $this->url_admin = new URLAdmin();
        $this->statistics = new Statistics();
        $auth = $this->checkAuth();
        if ($check_auth && !$auth) {
            $this->redirectAuth();
        }
        $this->setMenu();
        $this->setPageInfo();
        $this->template->set("auth", $auth);
        $this->template->set("message", $this->message());
        $this->template->set("message_color", $this->message_color());
        $this->template->set("content", $this->getContent());
        $this->template->set("action", $this->url_admin->action());
        $this->template->set("title", $this->title);
        $this->template->set("meta_desc", $this->meta_desc);
        $this->template->set("meta_key", $this->meta_key);
        $this->template->set("pages", $this->getPages());
        $this->template->display("main");
    }

    private function getPages()
    {
        $pages = array();
        for ($i = 1; $i <= $this->page_info["count"]; $i++) {
            $pages[] = $this->url_admin->page($i);
        }
        return $pages;
    }

    private function setPageInfo()
    {
        $this->page_info["page"] = isset($this->data["page"]) ? $this->data["page"] : 1;
        if ($this->page_info["page"] <= 0) {
            $this->notFound();
        }
        $this->page_info["offset"] = ($this->page_info["page"] - 1) * $this->config->pagination_count;
    }

    private function setMenu()
    {
        $this->template->set("index", $this->url_admin->index());
        $this->template->set("link_products", $this->url_admin->products());
        $this->template->set("link_orders", $this->url_admin->orders());
        $this->template->set("link_items", $this->url_admin->items());
        $this->template->set("link_brands", $this->url_admin->brands());
        $this->template->set("link_discounts", $this->url_admin->discounts());
        $this->template->set("link_statistics", $this->url_admin->statistics());
        $this->template->set("link_colors", $this->url_admin->colors());
        $this->template->set("logout", $this->url_admin->logout());
    }

    private function checkAuth()
    {
        $auth = new Auth();
        return $auth->checkAdmin($_SESSION["login"], $_SESSION["password"]);
    }

    private function redirectAuth()
    {
        $this->redirect($this->url_admin->auth());
    }

    protected function getDirTmpl()
    {
        return $this->config->dir_tmpl_admin;
    }

}
