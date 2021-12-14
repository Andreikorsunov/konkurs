<?php
$serverinimi='localhost';
$kasutajanimi='andrei17';
$parool='123456';
$andmebaasinimi='andrei17';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("UTF-8");
/*CREATE TABLE konkurs(
    id int primary key AUTO_INCREMENT,
    nimi varchar(50),
    pilt text,
    lisamisaeg datetime,
    punktid int DEFAULT 0,
    kommentaar text DEFAULT ' ',
    avalik int default 1)*/
?>
