<?php

include 'config.php';
include 'elements.php';

class Site {
    private $content;

    function __construct($c) {
        $this->content = $c;
    }

    function showHeader() {
        $header = new Header();
        $header->addTitle($this->content->getTitle());
        $header->show();
    }

    function show() {
        global $config;

        include $config['template_path']."/page.php";
    }
}
?>
