<?php

include 'config.php';
include 'elements.php';

class Site {
    private
        $content,
        $html;

    function __construct($c) {
        $this->content = $c;
#        $this->html = new Block();
#        $this->html->name = "html";
    }

    function showHeader() {
        $header = new Header();
        $header->addTitle($this->content->getTitle());
        echo $header->render();
    }

    function showBody() {
        $body = new Block();
        $body->name = "body";
        echo $body->render();
    }

    function show() {
        global $config;

#        echo $this->html->render();
        include $config['template_path']."/page.php";
    }
}
?>
