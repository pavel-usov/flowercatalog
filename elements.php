<?php
class SimpleElement {
    protected
        $options = array();
    public
        $name;

    function __construct ($n = "") {
        $this->name = $n;
    }

    function setOption($o, $v = NULL) {
        $this->options[$o] = $v;
    }

    function render() {
        $opts = "";
        foreach (array_keys($this->options) as $o) {
            $opts .= " ".$o;
            if ($this->options[$o] != NULL) {
                $opts .= "=\"".$this->options[$o]."\"";
            }            
        }
        return "<".$this->name.$opts.">";
    }
}

class Element extends SimpleElement {
    public
        $content = NULL;

    function render() {
        return parent::render().$this->content."</".$this->name.">";
    }
}

class BlockElement {
    protected
        $indent = "";
    public
        $element = NULL,
        $nextElement = NULL;

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
        $elements = NULL,
        $curElement = NULL;

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
        $title = new Element("title");
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
        return Element::render();
    }

    function newHeader($t) {
        $b = new Header($t);
        $b->level = $this->level + 1;
        $b->name = "h".$this->level;
        parent::addElement($b);
        return $b;
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

class Image extends SimpleElement {
    function __construct($i = NULL) {
        $this->name = "img";
        if ($i != NULL) {
            $this->setOption("src", $i);
        }
    }
}

class Text {
    public
        $plainText,
        $lineLen = 80;

    protected
        $content;

    function __construct($t) {
        $this->plainText = $t;
    }

    function prepareContent() {
        $search_list = array("<", ">");
        $replace_list = array("&lt;", "&gt;");
        $this->content = str_replace($search_list, $replace_list, $this->plainText);
    }

    function mdFormat() {
        $search_list = array("/\*(.*?)\*/");
        $replace_list = array("<em>$1</em>");
        $this->content = preg_replace($search_list, $replace_list, $this->content);
    }

    function render() {
        $this->prepareContent();
        $this->mdFormat();
        return wordwrap($this->content, $this->lineLen, "\n" );
    }
}
?>
