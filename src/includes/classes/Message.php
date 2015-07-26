<?php
namespace HouSplit;

class Message {
    private $title;
    private $message;

    public function __construct($title = null, $message) {
        $this->title = $title;
        $this->message = $message;
    }

    public function get_title() {
        return $this->title;
    }

    public function get_message() {
        return $this->message;
    }

    public function show() {
        echo '<div class="title">' . $this->title . '</div>';
        echo '<p>' . $this->message . '</p>';
    }
}
?>