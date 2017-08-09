<?php
class Element {
    public
        $option,
        $content;

    protected
        $snippet;

    function showElement() {
        require $this->snippet;
    }
}
?>
