<?php
require_once "adminform_class.php";

class AdminColorsContent extends AdminForm
{

    protected $title = "Цвета";
    protected $meta_data = "Таблица политры цветов";
    protected $maeta_key = "цвета, список цветов";

    protected function getFormData()
    {
        $form_data = array();
        $form_data["fields"] = array("color_title", "color");
        $form_data["func_add"] = "add_color";
        $form_data["func_edit"] = "edit_color";
        $form_data["title_add"] = "Добавление нового цвета";
        $form_data["title_edit"] = "Редактирование цвета";
        $form_data["get"] = $this->color->get($this->data["id"]);
        $form_data["get"]["color_title"] = $form_data["get"]["title"];
        $form_data["form_t"] = "color_form";
        $form_data["t"] = "colors";
        $form_data["obj"] = $this->color;
        $form_data["table_data"] = $this->color->getTableData($this->config->pagination_count, $this->page_info["offset"]);

        return $form_data;
    }
}
