<?php
require_once "globalmessage_class.php";

class Message extends GlobalMessage
{

    public function __construct()
    {
        parent::__construct("messages");
    }
}
