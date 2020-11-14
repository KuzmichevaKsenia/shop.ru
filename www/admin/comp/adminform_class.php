<?php
require_once "adminmodules_class.php";

abstract class AdminForm extends AdminModules
{

    protected function getContent()
    {
        $form_data = $this->getFormData();
        $form = false;
        if ($this->data["func"] == "new") {
            $form = true;
            $fields = array();
            for ($i = 0; $i < count($form_data["fields"]); $i++) {
                $fields[$form_data["fields"][$i]] = $_SESSION[$form_data["fields"][$i]];
            }
            $this->template->set("func", $form_data["func_add"]);
            $this->template->set("form_title", $form_data["title_add"]);
        } elseif ($this->data["func"] == "edit") {
            $form = true;
            $data_info = $form_data["get"];
            if (!$data_info) {
                $this->notFound();
            }
            $fields = array();
            for ($i = 0; $i < count($form_data["fields"]); $i++) {
                $fields[$form_data["fields"][$i]] = $data_info[$form_data["fields"][$i]];
            }
            $this->template->set("func", $form_data["func_edit"]);
            $this->template->set("id", $this->data["id"]);
            $this->template->set("form_title", $form_data["title_edit"]);
        }
        if ($form) {
            foreach ($fields as $name => $value) {
                $this->template->set($name, $value);
            }
            return $form_data["form_t"];
        } else {
            $table_data = $form_data["table_data"];
            $this->page_info["count"] = ceil($form_data["obj"]->getCount() / $this->config->pagination_count);
            if ($this->page_info["count"] < $this->page_info["page"]) {
                $this->notFound();
            }
            $this->template->set("link_new", $this->url_admin->newElement());
            $this->template->set("table_data", $table_data);
            $this->template->set("page_number", $this->page_info["page"]);
            return $form_data["t"];
        }
    }

    abstract protected function getFormData();
}
