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
    protected
        $level,
        $nextElement;

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
    private
        $elements,
        $curElement;

    function __construct() {
        $this->elements = NULL;
        $this->nextElement = NULL;
        $this->content = NULL;
    }

    function addElement($b) {
        $b->incLevel();
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
            $txt .= $e->render();
            $e = $e->nextElement;
        }
        return "<".$this->name.">\n".$txt."</".$this->name.">\n";
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
