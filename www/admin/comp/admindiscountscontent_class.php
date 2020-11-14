<?php
require_once "adminform_class.php";

class AdminDiscountsContent extends AdminForm
{

    protected $title = "Купоны";
    protected $meta_data = "Страница с купонами";
    protected $maeta_key = "кцпоны, список купонов";

    protected function getFormData()
    {
        $form_data = array();
        $form_data["fields"] = array("promocode", "value");
        $form_data["func_add"] = "add_discount";
        $form_data["func_edit"] = "edit_discount";
        $form_data["title_add"] = "Добавление купона";
        $form_data["title_edit"] = "Редактирование купона";
        $form_data["get"] = $this->discount->get($this->data["id"]);
        $form_data["get"]["promocode"] = $form_data["get"]["code"];
        $form_data["form_t"] = "discount_form";
        $form_data["t"] = "discounts";
        $form_data["obj"] = $this->discount;
        $form_data["table_data"] = $this->discount->getTableData($this->config->pagination_count, $this->page_info["offset"]);
        return $form_data;
    }
}
