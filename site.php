<?php

include 'config.php';

class Site {
    private $content;

    function __construct($c) {
        $this->content = $c;
    }

    function showHeader() {
        if (($title = $this->content->getTitle()) != NULL) {
            echo $title;
        }
    }

    function show() {
        global $config;

        include $config['template_path']."/page.php";
    }
}
?>
