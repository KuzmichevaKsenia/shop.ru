<?php
require_once "config_class.php";
require_once "email_class.php";
require_once "adminemail_class.php";

class Mail
{

    private $config;
    private $email;
    private $adminemail;

    public function __construct()
    {
        $this->config = new Config();
        $this->email = new Email();
        $this->adminemail = new Adminemail();
    }

    public function send($to, $data, $template, $from = "")
    {
        $data["sitename"] = $this->config->sitename;
        if ($from == "") {
            $from = $this->config->admemail;
        }
        $subject = $this->email->getTitle($template);
        $message = $this->email->getText($template);
        $headers = "From: $from\r\nReply-To: $from\r\nContent-type: text/html; charset=utf-8\r\n";
        foreach ($data as $key => $value) {
            $subject = str_replace("%$key%", $value, $subject);
            $message = str_replace("%$key%", $value, $message);
        }
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        return mail($to, $subject, $message, $headers);
    }

    public function sendToAdmin($data, $template, $from = "")
    {
        $data["sitename"] = $this->config->sitename;
        if ($from == "") {
            $from = $this->config->admemail;
        }
        $subject = $this->adminemail->getTitle($template);
        $message = $this->adminemail->getText($template);
        $headers = "From: $from\r\nReply-To: $from\r\nContent-type: text/html; charset=utf-8\r\n";
        foreach ($data as $key => $value) {
            $subject = str_replace("%$key%", $value, $subject);
            $message = str_replace("%$key%", $value, $message);
        }
        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        mail('kuzmichevaky@mail.ru', $subject, $message, $headers);
        return mail($this->config->admemail, $subject, $message, $headers);
    }
}
