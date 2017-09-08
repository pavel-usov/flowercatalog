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
        return "<".$this->name.">".$this->content."</".$this->name.">";
    }
}

class BlockElement extends Element {
    protected
        $indent,
        $nextElement;

    function __construct() {
        $this->indent = "";
    }

    function incIndent() {
        $this->indent .= "    ";
    }

    function render() {
        return $this->indent.parent::render()."\n";
    }
}

class Block extends BlockElement {
    private
        $elements,
        $curElement;

    function __construct() {
        $this->elements = NULL;
        $this->nextElement = NULL;
    }

    function addElement($b) {
        if ($this->elements == NULL) {
            $this->elements = $b;
            $this->curElement = $b;
            return;
        }
        $this->curElement->nextElement = $b;
        $this->curElement = $b;
    }

    function render() {
        $txt = "";
        $e = $this->elements;
        while ($e != NULL) {
            $e->indent = $this->indent;
            $e->incIndent();
            $txt .= $e->render();
            $e = $e->nextElement;
        }
        return $this->indent."<".$this->name.">\n".$txt.$this->indent."</".$this->name.">\n";
    }
}

class PageHeader extends Block {
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

class Header extends Block {
    protected
        $level;
    
    function __construct($t) {
        $this->level = 1;
        $this->name = "h1";
        $this->content = $t;
    }

    function render() {
        return BlockElement::render();
    }

    function addElement($b) {
        $b->level = $this->level++;
        $b->name = "h".$this->level;
        parent::addElement($b);
    }
}

class TblOfContent extends Header {
    function __construct() {
        $this->level = 0;
    }
}
?>
