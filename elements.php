<?php
class Element {
    public
        $name,
        $content;

    function __construct() {
        $this->name = "";
        $this->content = "";
    }

    function show() {
        return "<".$this->name.">".$this->content."<".$this->name."/>";
    }
}

class BlockElement extends Element {
    protected $level;

    function __construct() {
        $this->level = 0;
        $this->content = NULL;
    }
}

class Header extends BlockElement {
    function __construct() {
        $this->name = "head";
    }

    function addTitle($t) {
        $title = new Element;
        $title->name = "title";
        $title->content = $t;
        $this->content = $title;
    }

    function show() {
        echo "<".$this->name.">\n";
        echo "    ".$this->content->show()."\n";
        echo "</".$this->name.">\n";
    }
}
?>
