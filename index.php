<?php
include 'site.php';
include 'flowercatalog.php';

$content = new FlowerCatalog();
$site = new Site($content);

$site->show(); 
?>
