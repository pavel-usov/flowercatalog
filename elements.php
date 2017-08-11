<?php
class Element {
    public
        $name,
        $content;

    function __construct() {
        $this->name = "";
        $this->content = "";
    }

    function render() {
        return "<".$this->name.">".$this->content."<".$this->name."/>";
    }
}

class BlockElement extends Element {
    protected $level;

    function __construct() {
        $this->level = "";
    }

    function incLevel() {
        $this->level .= "    "; 
    }

    function render() {
        return $this->level.parent::render()."\n";
    }
}

class Block extends BlockElement {
    function __construct() {
        $this->content = NULL;
    }

    function addElement($b) {
        $b->incLevel();
        $this->content = $b;
    }

    function render() {     
        $this->content == NULL ? $c = "" : $c = $this->content->render();
        return "<".$this->name.">\n".$c."</".$this->name.">\n";
    }
}

class Header extends Block {
    function __construct() {
        $this->name = "head";
    }

    function addTitle($t) {
        $title = new BlockElement;
        $title->name = "title";
        $title->content = $t;
        $this->addElement($title);
    }
}
?>
