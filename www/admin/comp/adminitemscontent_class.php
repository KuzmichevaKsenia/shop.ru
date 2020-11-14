<?php
require_once "adminform_class.php";

class AdminItemsContent extends AdminForm
{

    protected $title = "Разделы";
    protected $meta_data = "Страница с разделами";
    protected $maeta_key = "разделы, список разделов";

    protected function getFormData()
    {
        $form_data = array();
        $form_data["fields"] = array("item_title");
        $form_data["func_add"] = "add_item";
        $form_data["func_edit"] = "edit_item";
        $form_data["title_add"] = "Добавление раздела";
        $form_data["title_edit"] = "Редактирование раздела";
        $form_data["get"] = $this->item->get($this->data["id"]);
        $form_data["get"]["item_title"] = $form_data["get"]["title"];
        $form_data["form_t"] = "item_form";
        $form_data["t"] = "items";
        $form_data["obj"] = $this->item;
        $form_data["table_data"] = $this->item->getTableData($this->config->pagination_count, $this->page_info["offset"]);
        return $form_data;
    }
}
