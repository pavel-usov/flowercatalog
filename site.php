<?php

include 'config.php';

class Site {
    private $content;

    function __construct($c) {
        $content = $c;
    }

    function show() {
        global $config;

        include $config['template_path']."/page.php";
    }
}
?>
