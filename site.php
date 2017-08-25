<?php

include 'config.php';
include 'elements.php';

class Site {
    private
        $content,
        $page;

    function __construct($c) {
        $this->content = $c;
        $this->page = new Block();
        $this->page->name = "html";
    }

    function addHeader() {
        $header = new Header();
        $header->addTitle($this->content->getTitle());
        $this->page->addElement($header);
#        echo $header->render();
    }

    function addBody() {
        $body = new Block();
        $body->name = "body";
        $this->page->addElement($body);
#        echo $body->render();
    }

    function show() {
        global $config;

        include $config['template_path']."/page.php";
        echo $this->page->render();
    }
}
?>
