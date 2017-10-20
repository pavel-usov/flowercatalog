<!doctype html>
<?php
    $this->addPageHeader();
    $body = $this->addPageBody();

    $h = new Header("My Favorite Flowers Catalog");
    $body->addElement($h);

    $g = new BlockGroup();
    $sh = new Header("Flower: Jasmin", $h);
    $g->addElement($sh);

    $body->addElement($g);

    $i = new Image("jasmin.jpg");
    $body->addElement($i);
?>
