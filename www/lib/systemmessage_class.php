<?php

class SystemMessage
{

    public function __construct()
    {
        session_start();
    }

    public function message($name, $result = false, $color = "red")
    {
        if ($name == "UNKNOWN_ERROR") {
            return $this->unknownError();
        }
        $_SESSION["message"] = $name;
        $_SESSION["message_color"] = $color;
        return $result;
    }

    public function pageMessage($name, $result = true)
    {
        if ($name == "UNKNOWN_ERROR") {
            return $this->unknownError(true);
        }
        $_SESSION["page_message"] = $name;
        return $result;
    }

    public function unknownError($page = false)
    {
        if ($page) {
            $_SESSION["page_message"] = "UNKNOWN_ERROR";
        } else {
            $_SESSION["message"] = "UNKNOWN_ERROR";
        }
        return false;
    }
}
