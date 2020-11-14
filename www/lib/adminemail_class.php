<?php
require_once "complexmessage_class.php";

class Adminemail extends ComplexMessage
{

    public function __construct()
    {
        parent::__construct("adminemails");
    }

}
