<?php

class PHP_Email_Form
{
    private $to = "jeffryafandi1@gmail.com"; // Change this to your receiving email address
    private $from_name;
    private $from_email;
    private $subject;
    private $message;
    public $smtp = array(); // Optional: Set SMTP configuration here

    public function add_message($message, $label = '', $length = 0)
    {
        if ($length > 0) {
            $message = substr($message, 0, $length);
        }
        $this->message .= strlen($label) > 0 ? $label . ": " . $message . "\n" : $message . "\n";
    }

    public function send()
    {
        $headers = "From: " . $this->from_name . " <" . $this->from_email . ">" . "\r\n";
        $headers .= "Reply-To: " . $this->from_email . "\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n";

        if (!empty($this->smtp)) {
            ini_set("SMTP", $this->smtp['host']);
            ini_set("smtp_port", $this->smtp['port']);
            ini_set("sendmail_from", $this->from_email);

            if (!empty($this->smtp['username']) && !empty($this->smtp['password'])) {
                $headers .= "Authorization: Basic " . base64_encode($this->smtp['username'] . ":" . $this->smtp['password']) . "\r\n";
            }
        }

        return mail($this->to, $this->subject, $this->message, $headers);
    }
}

?>
