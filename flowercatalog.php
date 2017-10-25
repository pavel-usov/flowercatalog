<?php
class FlowerCatalog {
    function __construct() {
    }

    function getTitle() {
        return "Flower catalog";
    }
}

class MainPage {
    public
        $tblOfContent,
        $template;

    function __construct() {
        $this->tblOfContent = new TblOfContent();
        $this->template = "page.php";
    }
}
?>
