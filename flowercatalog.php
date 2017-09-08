<?php
class FlowerCatalog {
    function __construct() {
    }

    function getTitle() {
        return "Flower catalog";
    }
}

class MainPage {
    private
        $tblOfContent;

    public
        $template;

    function __construct() {
        $this->tblOfContent = new TblOfContent();
        $this->template = "page.php";
    }
}
?>
