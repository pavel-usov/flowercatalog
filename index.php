<?php
include 'site.php';
include 'flowercatalog.php';

$content = new Flowercatalog();
$site = new Site($content);

$site->show(); 
?>
