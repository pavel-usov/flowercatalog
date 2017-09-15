<?php

include 'config.php';
include 'elements.php';

class OUTPUT {
    const HTML = 1;
}

class Site {
    private
        $content,
        $page;

    function __construct($c, $type) {
        $this->content = $c;
        if ($type == OUTPUT::HTML) {
            $this->page = new Block();
            $this->page->name = "html";
        }
    }

    function addPageHeader() {
        $header = new PageHeader();
        $header->addTitle($this->content->getTitle());
        $this->page->addElement($header);
        return $header;
    }

    function addPageBody() {
        $body = new Block();
        $body->name = "body";
        $this->page->addElement($body);
        return $body;
    }

    function show($Page) {
        global $config;

        include $config['template_path']."/".$Page->template;
        echo $this->page->render();
    }
}
?>
