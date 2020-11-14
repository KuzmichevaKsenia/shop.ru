<?php
require_once "adminform_class.php";

class AdminBrandsContent extends AdminForm
{

    protected $title = "Бренды";
    protected $meta_data = "Страница с брендами";
    protected $maeta_key = "бренды, список брендов";

    protected function getFormData()
    {
        $form_data = array();
        $form_data["fields"] = array("brand_title", "country", "description");
        $form_data["func_add"] = "add_brand";
        $form_data["func_edit"] = "edit_brand";
        $form_data["title_add"] = "Добавление бренда";
        $form_data["title_edit"] = "Редактирование бренда";
        $form_data["get"] = $this->brand->get($this->data["id"]);
        $form_data["get"]["brand_title"] = $form_data["get"]["title"];
        $form_data["form_t"] = "brand_form";
        $form_data["t"] = "brands";
        $form_data["obj"] = $this->brand;
        $form_data["table_data"] = $this->brand->getTableData($this->config->pagination_count, $this->page_info["offset"]);
        return $form_data;
    }
}
