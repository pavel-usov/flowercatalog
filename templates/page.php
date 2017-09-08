<!doctype html>
<?php
    $this->addHeader();
    $body = $this->addBody();

    $h = new Header("My Favorite Flowers Catalog");
    $body->addElement($h);

    $sh = new Header("Flower: Jasmin");
    $h->addElement($sh);
    $body->addElement($sh);
?>
