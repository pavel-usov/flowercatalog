<?php
class SimpleElement {
    protected
        $options = array();
    public
        $name,
        $newline = true;

    function __construct ($n = '') {
        $this->name = $n;
    }

    function setOption($o, $v = NULL) {
        $this->options[$o] = $v;
    }

    function render() {
        $opts = '';
        foreach (array_keys($this->options) as $o) {
            $opts .= ' '.$o;
            if ($this->options[$o] != NULL) {
                $opts .= '="'.$this->options[$o].'"';
            }
        }
        return '<'.$this->name.$opts.'>';
    }
}

class Element extends SimpleElement {
    public
        $content = NULL;

    function render() {
        return parent::render().$this->content.'</'.$this->name.'>';
    }
}

class BlockElement {
    protected
        $indent = '';
    public
        $element = NULL,
        $nextElement = NULL;

    function incIndent() {
        $this->indent .= '    ';
    }

    function render() {
        $txt = str_replace("\n", "\n".$this->indent, $this->element->render());
        if ($this->element->newline == true) $txt .= "\n";
        return $this->indent.$txt;
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
        $txt = '';
        $doIndent = true;
        $e = $this->elements;
        while ($e != NULL) {
            if ($doIndent) $e->incIndent();
            $txt .= $e->render();
            $e->element->newline == false ? $doIndent = false: $doIndent = true;
            $e = $e->nextElement;
        }
        return SimpleElement::render()."\n".$txt.'</'.$this->name.'>';
    }
}

class PageHeader extends Block {
    function __construct() {
        $this->name = 'head';
    }

    function addTitle($t) {
        $title = new Element('title');
        $title->content = $t;
        $this->addElement($title);
    }
}

class Header extends Block {
    protected
        $level;
    
    function __construct($t) {
        $this->level = 1;
        $this->name = 'h1';
        $this->content = $t;
    }

    function setLevel($l) {
        $this->level = $l;
        $this->name = 'h'.$l;
    }

    function render() {
        return Element::render();
    }

    function newHeader($t) {
        $b = new Header($t);
        $b->setLevel($this->level + 1);
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
        $this->name = 'div';
    }
}

class Image extends SimpleElement {
    function __construct($i = NULL) {
        $this->name = 'img';
        if ($i != NULL) {
            $this->setOption('src', $i);
        }
    }
}

class Text {
    public
        $plainText,
        $newline = true,
        $lineLen = 80;

    protected
        $content;

    function __construct($t) {
        $this->plainText = $t;
    }

    function prepareContent() {
        $search_list = array('<', '>');
        $replace_list = array('&lt;', '&gt;');
        $this->content = str_replace($search_list, $replace_list, $this->plainText);
    }

    function renderElement($n, $c) {
        $o = new Element($n);
        $o->content = $c;
        $t = $o->render();
        unset($o);
        return $t;
    }

    function mdFormat() {
        $search_list = array(
            '/([A-Z a-z*_]|^)(\*\*|__)(.*?)\2/',              # strong
            '/([A-Z a-z*_]|^)(\*|_)(.*?)([A-Z a-z*_])\2/',    # em
            '/\\\(\*|_)/'
        );
        $replace_list = array(
            $this->renderElement('strong', '\3'),
            '\1'.$this->renderElement('em', '\3\4'),
            '\1'
        );
        $this->content = preg_replace($search_list, $replace_list, $this->content);
    }

    function render() {
        $this->prepareContent();
        $this->mdFormat();
        return wordwrap($this->content, $this->lineLen, "\n" );
    }
}

class Form extends Block {
    function __construct($action = NULL, $method = 'post') {
        $this->name = 'form';
        if ($action != NULL) $this->setOption('action', $action);
        if ($method != NULL) $this->setOption('method', $method);
    }

    function addRadio($group, $value, $desc) {
        $e = new SimpleElement('input');
        $e->setOption('type', 'radio');
        $e->setOption('name', $group);
        $e->setOption('value', $value);
        $this->addElement($e);
        $this->addElement($desc);
        return $e;
    }

    function addSubmitButton($value) {
        $e = new SimpleElement('input');
        $e->setOption('type', 'submit');
        $e->setOption('value', $value);
        $this->addElement($e);
        return $e;
    }
}
?>
