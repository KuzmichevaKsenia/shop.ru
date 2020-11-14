<?php
require_once "globalmessage_class.php";

abstract class ComplexMessage extends GlobalMessage
{

    public function getTitle($name)
    {
        return $this->get($name . "_TITLE");
    }

    public function getText($name)
    {
        return $this->get($name . "_TEXT");
    }

}
