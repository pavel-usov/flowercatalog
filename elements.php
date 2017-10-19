<?php
class SimpleElement {
    public
        $name;

    function render() {
        return "<".$this->name.">";
    }
}

class Element extends SimpleElement {
    public
        $content;

    function __construct() {
        $this->name = "";
        $this->content = NULL;
    }

    function render() {
        return parent::render().$this->content."</".$this->name.">";
    }
}

class BlockElement {
    protected
        $indent;
    public
        $element,
        $nextElement;

    function __construct() {
        $this->indent = "";
        $this->element = NULL;
    }

    function incIndent() {
        $this->indent .= "    ";
    }

    function render() {
        $txt = str_replace("\n", "\n".$this->indent, $this->element->render());
        return $this->indent.$txt."\n";
    }
}

class Block extends Element {
    private
        $elements,
        $curElement;

    function __construct() {
        $this->elements = NULL;
        $this->nextElement = NULL;
    }

    function addElement($b) {
        $e = new BlockElement();
        $e->element = $b;
        if ($this->elements == NULL) {
            $this->elements = $e;
            $this->curElement = $e;
            return;
        }
        $this->curElement->nextElement = $e;
        $this->curElement = $e;
    }

    function render() {
        $txt = "";
        $e = $this->elements;
        while ($e != NULL) {
            $e->incIndent();
            $txt .= $e->render();
            $e = $e->nextElement;
        }
        return SimpleElement::render()."\n".$txt."</".$this->name.">";
    }
}

class PageHeader extends Block {
    function __construct() {
        $this->name = "head";
    }

    function addTitle($t) {
        $title = new Element;
        $title->name = "title";
        $title->content = $t;
        $this->addElement($title);
    }
}

class Header extends Block {
    protected
        $level;
    
    function __construct($t, $p = NULL) {
        $this->level = 1;
        $this->name = "h1";
        $this->content = $t;
        if ($p != NULL) $p->addElement($this);
    }

    function render() {
        return Element::render();
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

class BlockGroup extends Block {
    function __construct() {
        $this->name = "div";
    }
}
?>
