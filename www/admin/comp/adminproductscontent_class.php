<?php
require_once "adminform_class.php";

class AdminProductsContent extends AdminForm
{

    protected $title = "Товары";
    protected $meta_data = "Страница с товарами";
    protected $meta_key = "товары, список товаров";

    protected function getFormData()
    {
        $form_data = array();
        $this->template->set("items", $this->item->getAllData());
        $this->template->set("brands", $this->brand->getAllData());
        $this->template->set("colors", $this->color->getAllData());
        $this->template->set("sizes", $this->size->getAllData());
        $form_data["fields"] = array("id", "code_name", "pr_title", "item_id", "brand_id", "collection", "composition", "price", "before_sale_price", "units");
        $form_data["func_add"] = "add_product";
        $form_data["func_edit"] = "edit_product";
        $form_data["title_add"] = "Добавление товара";
        $form_data["title_edit"] = "Редактирование товара";
        $form_data["get"] = $this->product->get($this->data["id"], $this->item->getTableName());

        $units = $this->unit->getAllOnFieldByValues("product_id", array($this->data["id"]));
        $units = $units[strtoupper($this->data["id"])];
        if ($units) {
            foreach ($units as $key => $unit) {
                $units[$key]["sizes"] = $this->setIdOnArrayKeys($unit["sizes"]);
            }
        }
        $form_data["get"]["units"] = $units;

        $form_data["get"]["pr_title"] = $form_data["get"]["title"];
        $form_data["form_t"] = "product_form";
        $form_data["t"] = "products";
        $form_data["obj"] = $this->product;
        $form_data["table_data"] = $this->product->getTableData($this->item->getTableName(), $this->config->pagination_count, $this->page_info["offset"]);

        return $form_data;
    }

    private function setIdOnArrayKeys($array)
    {
        $result = array();
        foreach ($array as $val) {
            $result[$val["id"]] = $val;
        }
        return $result;
    }
}
