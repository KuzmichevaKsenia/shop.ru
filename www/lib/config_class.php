<?php

class Config
{
    public $sitename = "shop.ru";
    public $address = "http://shop.ru/";

    public $db_host = "localhost";
    public $db_user = "root";
    public $db_password = "";
    public $db_name = "ksenia_shop";
    public $db_prefix = "m_";

    public $address_admin = "http://shop.ru/admin/";
    public $admemail = "mybox@mail.ru";
    public $adm_login = "Admin";
    public $adm_password = "6c22ecbe78cab6b3bf339bc01df2e8e8";
    public $admname = "Ксения Кузьмичева";
    public $secret = "KRJHGKJLRRFE";
    public $sym_query = "{?}";

    public $count_on_page = 12;
    public $count_others = 6;
    public $pagination_count = 10;

    public $dir_text = "lib/text/";
    public $dir_tmpl = "tmpl/";
    public $dir_tmpl_admin = "admin/tmpl/";
    public $dir_img_products = "images/products/";
    public $dir_img_items = "images/items/";
    public $dir_img_brands = "images/brands/";

    public $max_name = 255;
    public $max_title = 255;
    public $max_text = 65535;

    public $max_size_img = 8000000;
    public $default_img_extension = ".jpg";

}
