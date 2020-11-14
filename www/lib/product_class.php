<?php
require_once "global_class.php";

class Product extends GlobalClass
{

    public function __construct()
    {
        parent::__construct("products");
    }

    public function getAllData($count)
    {
        return $this->transform($this->getAll("date", false, $count));
    }

    public function getAllBigData()
    {
        return $this->transform($this->getAll());
    }

    public function getAllTable()
    {
        return $this->getAll("id");
    }

    public function getTableData($item_table, $count, $offset)
    {
        $l = $this->getL($count, $offset);
        $query = "SELECT {$this->table_name}.id,
		{$this->table_name}.item_id,
		{$this->table_name}.brand_id,
		{$this->table_name}.title,
		{$this->table_name}.code_name,
		{$this->table_name}.price,
		{$this->table_name}.collection,
		{$this->table_name}.composition,
		{$this->table_name}.date,
		{$this->table_name}.before_sale_price,
		{$item_table}.title as item
		FROM $this->table_name
	    INNER JOIN $item_table ON {$item_table}.id = {$this->table_name}.item_id 
	    ORDER BY date DESC $l";
        return $this->transform($this->db->select($query));
    }

    protected function transformElement($product)
    {
        $product["link"] = $this->url->product($product["id"]);
        $product["brand"] = $this->getCell("title", $this->config->db_prefix . "brands", "id", $product["brand_id"]);
        $product["brand_link"] = $this->url->brand($product["brand_id"]);
        $product["link_admin_edit"] = $this->url->adminEditProduct($product["id"]);
        $product["link_admin_delete"] = $this->url->adminDeleteProduct($product["id"]);
        $product["date"] = $this->format->date($product["date"]);
        return $product;
    }

    private function checkSortUp($sort, $up)
    {
        return ((($sort === "title") || ($sort === "price")) && (($up === "1") || ($up === "0")));
    }

    public function getAllOnItemID($item_id, $sort, $up)
    {
        if (!$this->checkSortUp($sort, $up)) {
            return $this->transform($this->getAllOnField("item_id", $item_id));
        }
        return $this->transform($this->getAllOnField("item_id", $item_id, $sort, $up));
    }

    public function getAllOnBrandID($brand_id, $sort, $up)
    {
        if (!$this->checkSortUp($sort, $up)) {
            return $this->transform($this->getAllOnField("brand_id", $brand_id));
        }
        return $this->transform($this->getAllOnField("brand_id", $brand_id, $sort, $up));
    }

    public function getAllSort($sort, $up, $count)
    {
        if (!$this->checkSortUp($sort, $up)) {
            return $this->getAllData($count);
        }
        $l = $this->getL($count, 0);
        $desc = "";
        if (!$up) {
            $desc = "DESC";
        }
        $query = "SELECT * FROM
		    (SELECT * FROM $this->table_name ORDER BY date DESC $l) as t
			ORDER BY $sort $desc";
        return $this->transform($this->db->select($query));
    }

    public function get($id, $item_table)
    {
        if (!$this->check->code($id)) {
            return false;
        }
        $query = "SELECT {$this->table_name}.id,
		{$this->table_name}.item_id,
		{$this->table_name}.brand_id,
		{$this->table_name}.title,
		{$this->table_name}.price,
		{$this->table_name}.before_sale_price,
		{$this->table_name}.collection,
		{$this->table_name}.composition,
		{$this->table_name}.code_name,
		{$item_table}.title as item
		FROM $this->table_name
	    INNER JOIN $item_table ON {$item_table}.id = {$this->table_name}.item_id
		WHERE {$this->table_name}.id = " . $this->config->sym_query;
        return $this->transform($this->db->selectRow($query, array($id)));
    }

    public function getByIdUntransform($id)
    {
        return parent::get($id, true);
    }

    public function getAllOnIDs($ids)
    {
        return $this->transform($this->getRowsOnField("id", $ids));
    }

    public function getAllOnSale($sort, $up)
    {
        if (!$this->checkSortUp($sort, $up)) {
            return $this->transform($this->getAllOnDifferentFields("price", "before_sale_price"));
        }
        return $this->transform($this->getAllOnDifferentFields("price", "before_sale_price", $sort, $up));
    }

    public function getPriceOnIDs($ids)
    {
        $products = $this->getAllOnIDs($ids);
        $result = array();
        for ($i = 0; $i < count($products); $i++) {
            $result[$products[$i]["id"]] = $products[$i]["price"];
        }
        $amount = 0;
        for ($i = 0; $i < count($ids); $i++) {
            $amount += $result[$ids[$i]];
        }
        return $amount;
    }

    public function getOthers($product_info, $count)
    {
        $l = $this->getL($count, 0);
        $query = "SELECT * FROM $this->table_name WHERE (brand_id = " . $this->config->sym_query . " || item_id = " . $this->config->sym_query . ") AND id != " . $this->config->sym_query . " ORDER BY RAND() $l";
        return $this->transform($this->db->select($query, array($product_info["brand_id"], $product_info["item_id"], $product_info["id"])));
    }

    public function search($q, $sort, $up)
    {
        if (!$this->checkSortUp($sort, $up)) {
            return $this->transform(parent::search($q, array("title", "collection", "composition", "code_name")));
        }
        return $this->transform(parent::search($q, array("title", "collection", "composition", "code_name"), $sort, $up));
    }

    public function checkData($data, $id = false)
    {
        foreach ($data as $field => $value) {
            switch ($field) {
                case "code_name":
                    if (!$this->check->title($value)) {
                        return "ERROR_ID";
                    }
                    break;
                case "id":
                    if (!$this->check->code($value)) {
                        return "ERROR_ID";
                    }
                    $suspect_id = $this->getField("id", $value, "id");
                    if ($suspect_id && $suspect_id != $id) {
                        return "ERROR_EXISTS_CODE";
                    }
                    break;
                case "item_id":
                case "brand_id":
                    if (!$this->check->id($value)) {
                        return "UNKNOWN_ERROR";
                    }
                    break;
                case "title":
                    if (!$this->check->title($value)) {
                        return "ERROR_TITLE";
                    }
                    break;
                case "collection":
                    if (!$this->check->title($value)) {
                        return "ERROR_COLLECTION";
                    }
                    break;
                case "composition":
                    if (!$this->check->title($value)) {
                        return "ERROR_COMPOSITION";
                    }
                    break;
                case "price":
                    if (!$this->check->amount($value)) {
                        return "ERROR_PRICE";
                    }
                    if (!$this->check->amount($data["before_sale_price"])) {
                        return "ERROR_PRICE";
                    }
                    if ($value > $data["before_sale_price"]) {
                        return "ERROR_PRICE";
                    }
                    break;
                case "date":
                    if (!$this->check->ts($value)) {
                        return "UNKNOWN_ERROR";
                    }
                    break;
                default:
                    return true;
            }
        }
        return true;
    }

    public function existsID($id)
    {
        if (!$this->check->code($id)) {
            return false;
        }
        return $this->isExistsFV("id", $id);
    }
}
