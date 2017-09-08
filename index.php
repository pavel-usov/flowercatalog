<?php
include 'site.php';
include 'flowercatalog.php';

$content = new FlowerCatalog();
$site = new Site($content, OUTPUT::HTML);

$page = new MainPage();
$site->show($page); 
?>
