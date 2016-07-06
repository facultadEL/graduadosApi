<?php

include './notifications.php';

$noty = new Notification;

$noty->setData('Titulo prueba','Texto prueba');
$noty->showData();

?>