<?php

class Template
{ //шаблонизатор

    private $dir_tpl;
    private $data = array();

    public function __construct($dir_tpl)
    {
        $this->dir_tpl = $dir_tpl;
    }

    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function delete($name)
    {
        unset($this->data[$name]);
    }

    public function __get($name)
    { //вызывается автоматически при обращении через tpl-файл: <?=$this->($name)...
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return "";
    }

    public function display($template)
    { //вывод шаблона
        $template = $this->dir_tpl . $template . ".tpl";
        ob_start(); //вывод в буфер
        include($template);
        echo ob_get_clean(); //вывод буфера и его очистка
    }
}
