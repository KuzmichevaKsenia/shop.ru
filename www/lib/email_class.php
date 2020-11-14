<?php
require_once "complexmessage_class.php";

class Email extends ComplexMessage
{

    public function __construct()
    {
        parent::__construct("emails");
    }

}
